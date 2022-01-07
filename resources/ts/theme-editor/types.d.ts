export type ViewMode = "desktop" | "mobile" | "fullscreen";
export interface Setting {
  type: string;
  id: string;
  label: string;
  default?: unknown;
  info?: string;
  group?: string;
  [key: string]: unknown;
}

interface Block {
  type: string;
  name: string;
  limit: number;
  settings: Setting[];
}

export interface Section {
  slug: string;
  label: string;
  description: string;
  previewImageUrl: string;
  previewDescription: string;
  settings: Setting[];
  blocks?: Block[];
  maxBlocks?: number;
}

export interface BlockData {
  id: string;
  type: string;
  disabled: boolean;
  settings: Record<string, unknown>;
}
export interface SectionData extends BlockData {
  blocks: Record<string, BlockData>;
  blocks_order: string[];
}

export interface ThemeData {
  url: string;
  template: string;
  hasStaticContent: boolean;
  beforeContentSectionsOrder: string[];
  afterContentSectionsOrder: string[];
  sectionsOrder: string[];
  sections: Record<string, SectionData>;
}

export interface Template {
  icon?: string;
  label: string;
  template: string;
  url: string;
}
