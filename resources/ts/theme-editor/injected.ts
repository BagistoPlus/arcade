import morphdom from "morphdom";

declare global {
  interface Window {
    Livewire: any;
    themeData: any;
    themeSettings: any;
    availableSections: any;
    templates: any;
    initialState: any;
  }
}

window.addEventListener("DOMContentLoaded", () => {
  const editor = new Editor();
  editor.init();

  Object.keys(window.themeData.sections).forEach((sectionId) => {
    const section = window.themeData.sections[sectionId];
    if (Array.isArray(section.blocks)) {
      section.blocks = {};
      section.blocks_order = [];
    }
  });

  editor.postMessage("init", {
    themeData: window.themeData,
    themeSettings: window.themeSettings,
    availableSections: window.availableSections,
    templates: window.templates,
    models: window.initialState,
  });

  window.addEventListener("message", (event) => {
    switch (event.data.type) {
      case "activateSection":
        const section = document.querySelector(
          `[data-section-id="${event.data.data}"]`
        ) as HTMLElement;

        editor.activateSection(section);
        section.scrollIntoView({ behavior: "smooth" });
        break;

      case "clearActiveSection":
        editor.clearActiveSection();
        break;

      case "refresh":
        editor.refreshPreviewer(event.data.data);
        break;
    }
  });
});

class Editor {
  sectionOverlay!: HTMLElement;
  activeSectionId: string | null = null;

  init() {
    this.sectionOverlay = document.querySelector("#section-overlay") as HTMLElement;

    document.querySelectorAll(".arcade-section").forEach((section) => {
      section.addEventListener("mouseover", this.onSectionHover.bind(this, section as HTMLElement));

      section.addEventListener("mouseleave", ((event: Event) => {
        if (
          (event as any).toElement &&
          (event as any).toElement.parentElement?.id === "section-overlay"
        ) {
          return;
        }

        this.onSectionBlur.call(this, section as HTMLElement);
      }) as EventListener);
    });

    this.sectionOverlay.querySelectorAll(".btn").forEach((btn) => {
      btn.addEventListener("mouseenter", () => {
        this.sectionOverlay.style.display = "block";
      });
    });

    this.sectionOverlay
      .querySelector("#move-up")
      ?.addEventListener("click", this.onMoveActiveSectionUp.bind(this));

    this.sectionOverlay
      .querySelector("#move-down")
      ?.addEventListener("click", this.onMoveActiveSectionDown.bind(this));

    this.sectionOverlay
      .querySelector("#edit")
      ?.addEventListener("click", this.onEditActiveSection.bind(this));

    this.sectionOverlay
      .querySelector("#disable")
      ?.addEventListener("click", this.onToggleSection.bind(this));

    this.sectionOverlay
      .querySelector("#remove")
      ?.addEventListener("click", this.onRemoveActiveSection.bind(this));
  }

  postMessage(type: string, data: any) {
    window.parent.postMessage({ type, data }, window.origin);
  }

  activateSection(section: HTMLElement) {
    this.activeSectionId = section.dataset.sectionId as string;
    this.sectionOverlay.style.width = section.offsetWidth + "px";
    this.sectionOverlay.style.height = section.offsetHeight + "px";
    this.sectionOverlay.style.left = section.offsetLeft + "px";
    this.sectionOverlay.style.top = section.offsetTop + "px";
    this.sectionOverlay.style.display = "block";
  }

  clearActiveSection() {
    this.activeSectionId = null;
    this.sectionOverlay.style.display = "none";
  }

  onSectionHover(section: HTMLElement) {
    if (this.activeSectionId === section.dataset.sectionId) {
      return;
    }

    this.activateSection(section);
    this.postMessage("activateSection", section.dataset.sectionId);
  }

  onSectionBlur(section: HTMLElement) {
    if (this.activeSectionId === section.dataset.sectionId) {
      this.clearActiveSection();
    }
  }

  onMoveActiveSectionUp() {
    this.postMessage("moveSectionUp", this.activeSectionId);
  }

  onMoveActiveSectionDown() {
    this.postMessage("moveSectionDown", this.activeSectionId);
  }

  onEditActiveSection() {
    this.postMessage("editSection", this.activeSectionId);
  }

  onToggleSection() {
    console.log(this.activeSectionId);
    this.postMessage("toggleSection", this.activeSectionId);
  }

  onRemoveActiveSection() {
    this.postMessage("removeSection", this.activeSectionId);
  }

  refreshPreviewer(html: string) {
    console.log("refresh");
    const htmlDocument = new DOMParser().parseFromString(html, "text/html");

    morphdom(
      document.querySelector("html") as HTMLElement,
      htmlDocument.querySelector("html") as HTMLElement
    );

    // Let Alpine & Livewire do their things again
    if (window.Livewire) {
      window.Livewire.rescan();
    }

    if (window.Alpine) {
      // @ts-ignore
      window.Alpine.initTree(document.body);
    }
  }
}
