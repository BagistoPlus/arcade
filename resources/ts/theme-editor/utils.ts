import { Setting } from "./types";

export function groupSettings(settings: Setting[]) {
  const groupedSettings: Record<string, any> = {};

  settings.forEach((setting) => {
    const group = setting.group || "default";

    if (!groupedSettings[group]) {
      groupedSettings[group] = [];
    }

    groupedSettings[group].push(setting);
  });

  return groupedSettings;
}
