import "./injected"; // eslint-disable-line no-duplicate-imports
import morphdom from "morphdom";

declare global {
  interface Window {
    Livewire: any;
    themeData: any;
    availableSections: any;
  }
}

window.addEventListener("DOMContentLoaded", () => {
  const editor = new Editor();
  editor.init();
  editor.postMessage("init", {
    themeData: window.themeData,
    availableSections: window.availableSections,
  });

  window.addEventListener("message", (event) => {
    switch (event.data.type) {
      case "activateSection":
        const section = document.querySelector(
          `[data-section-id="${event.data.data}"]`
        ) as HTMLElement;

        editor.activateSection(section);
        section.scrollIntoView();
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
    this.sectionOverlay = document.querySelector(
      "#section-overlay"
    ) as HTMLElement;

    document.querySelectorAll(".arcade-section").forEach((section) => {
      section.addEventListener(
        "mouseover",
        this.onSectionHover.bind(this, section as HTMLElement)
      );

      section.addEventListener(
        "mouseleave",
        this.onSectionBlur.bind(this, section as HTMLElement)
      );
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
      ?.addEventListener("click", this.onDisableActiveSection.bind(this));

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

  onDisableActiveSection() {
    this.postMessage("disableSection", this.activeSectionId);
  }

  onRemoveActiveSection() {
    this.postMessage("removeSection", this.activeSectionId);
  }

  refreshPreviewer(html: string) {
    const htmlDocument = new DOMParser().parseFromString(html, "text/html");

    morphdom(
      document.querySelector("body") as HTMLElement,
      htmlDocument.querySelector("body") as HTMLElement
    );

    // Let Alpine & Livewire do their things again
    if (window.Alpine) {
      window.Alpine.start();
    }

    if (window.Livewire) {
      window.Livewire.rescan();
    }
  }
}
