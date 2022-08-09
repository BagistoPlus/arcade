<style>
  :root {
    /** light theme */
    --c: {{$theme->settings->light_primary_color}} {{arcade_color_rbg_vars($theme->settings->light_primary_color)}};
    --color-primary: {{ arcade_color_rbg_vars($theme->settings->light_primary_color ?? '#6750A4') }};
    --color-on-primary: {{ arcade_color_rbg_vars($theme->settings->light_on_primary_color ?? '#FFFFFF') }};
    --color-primary-container: {{ arcade_color_rbg_vars($theme->settings->light_primary_container_color ?? '#EADDFF') }};
    --color-on-primary-container:  {{ arcade_color_rbg_vars($theme->settings->light_on_primary_container_color ?? '#21005D') }};

    --color-secondary: {{ arcade_color_rbg_vars($theme->settings->light_secondary_color ?? '#625B71') }};
    --color-on-secondary: {{ arcade_color_rbg_vars($theme->settings->light_on_secondary_color ?? '#FFFFFF') }};
    --color-secondary-container: {{ arcade_color_rbg_vars($theme->settings->light_secondary_container_color ?? '#E8DEF8') }};
    --color-on-secondary-container:  {{ arcade_color_rbg_vars($theme->settings->light_on_secondary_container_color ?? '#1D192B') }};

    --color-tertiary: {{ arcade_color_rbg_vars($theme->settings->light_tertiary_color ?? '#7D5260') }};
    --color-on-tertiary: {{ arcade_color_rbg_vars($theme->settings->light_on_tertiary_color ?? '#FFFFFF') }};
    --color-tertiary-container: {{ arcade_color_rbg_vars($theme->settings->light_tertiary_container_color ?? '#FFD8E4') }};
    --color-on-tertiary-container:  {{ arcade_color_rbg_vars($theme->settings->light_on_tertiary_container_color ?? '#31111D') }};

    --color-error: {{ arcade_color_rbg_vars($theme->settings->light_error_color ?? '#B3261E') }};
    --color-on-error: {{ arcade_color_rbg_vars($theme->settings->light_on_error_color ?? '#FFFFFF') }};
    --color-error-container: {{ arcade_color_rbg_vars($theme->settings->light_error_container_color ?? '#F9DEDC') }};
    --color-on-error-container:  {{ arcade_color_rbg_vars($theme->settings->light_on_error_container_color ?? '#410E0B') }};

    --color-background: {{ arcade_color_rbg_vars($theme->settings->light_background_color ?? '#FFFBFE') }};
    --color-on-background: {{ arcade_color_rbg_vars($theme->settings->light_on_background_color ?? '#1C1B1F') }};

    --color-surface: {{ arcade_color_rbg_vars($theme->settings->light_surface_color ?? '#FFFBFE') }};
    --color-on-surface:  {{ arcade_color_rbg_vars($theme->settings->light_on_surface_color ?? '#1C1B1F') }};
    --color-surface-variant: {{ arcade_color_rbg_vars($theme->settings->light_surface_variant_color ?? '#E7E0EC') }};
    --color-on-surface-variant:  {{ arcade_color_rbg_vars($theme->settings->light_on_surface_variant_color ?? '#49454F') }};

    --color-outline: {{ arcade_color_rbg_vars($theme->settings->light_outline_color ?? '#79747E') }};
  }

  /** dark theme */
  @media (prefers-color-scheme: dark) {
    :roo {
      --color-primary: {{ arcade_color_rbg_vars($theme->settings->dark_primary_color ?? '#D0BCFF') }};
      --color-on-primary: {{ arcade_color_rbg_vars($theme->settings->dark_on_primary_color ?? '#381E72') }};
      --color-primary-container: {{ arcade_color_rbg_vars($theme->settings->dark_primary_container_color ?? '#4F378B') }};
      --color-on-primary-container:  {{ arcade_color_rbg_vars($theme->settings->dark_on_primary_container_color ?? '#EADDFF') }};

      --color-secondary: {{ arcade_color_rbg_vars($theme->settings->dark_secondary_color ?? '#CCC2DC') }};
      --color-on-secondary: {{ arcade_color_rbg_vars($theme->settings->dark_on_secondary_color ?? '#332D41') }};
      --color-secondary-container: {{ arcade_color_rbg_vars($theme->settings->dark_secondary_container_color ?? '#4A4458') }};
      --color-on-secondary-container:  {{ arcade_color_rbg_vars($theme->settings->dark_on_secondary_container_color ?? '#E8DEF8') }};

      --color-tertiary: {{ arcade_color_rbg_vars($theme->settings->dark_tertiary_color ?? '#EFB8C8') }};
      --color-on-tertiary: {{ arcade_color_rbg_vars($theme->settings->dark_on_tertiary_color ?? '#492532') }};
      --color-tertiary-container: {{ arcade_color_rbg_vars($theme->settings->dark_tertiary_container_color ?? '#633B48') }};
      --color-on-tertiary-container:  {{ arcade_color_rbg_vars($theme->settings->dark_on_tertiary_container_color ?? '#FFD8E4') }};

      --color-error: {{ arcade_color_rbg_vars($theme->settings->dark_error_color ?? '#F2B8B5') }};
      --color-on-error: {{ arcade_color_rbg_vars($theme->settings->dark_on_error_color ?? '#601410') }};
      --color-error-container: {{ arcade_color_rbg_vars($theme->settings->dark_error_container_color ?? '#8C1D18') }};
      --color-on-error-container:  {{ arcade_color_rbg_vars($theme->settings->dark_on_error_container_color ?? '#F2B8B5') }};

      --color-background: {{ arcade_color_rbg_vars($theme->settings->dark_background_color ?? '#1C1B1F') }};
      --color-on-background: {{ arcade_color_rbg_vars($theme->settings->dark_on_background_color ?? '#E6E1E5') }};

      --color-surface: {{ arcade_color_rbg_vars($theme->settings->dark_surface_color ?? '#1C1B1F') }};
      --color-on-surface:  {{ arcade_color_rbg_vars($theme->settings->dark_on_surface_color ?? '#E6E1E5') }};
      --color-surface-variant: {{ arcade_color_rbg_vars($theme->settings->dark_surface_variant_color ?? '#49454F') }};
      --color-on-surface-variant:  {{ arcade_color_rbg_vars($theme->settings->dark_on_surface_variant_color ?? '#CAC4D0') }};

      --color-outline: {{ arcade_color_rbg_vars($theme->settings->dark_outline_color ?? '#938F99') }};
    }
  }

  .dark, [dark], [data-theme="dark"] {
    --color-primary: {{ arcade_color_rbg_vars($theme->settings->dark_primary_color ?? '#D0BCFF') }};
    --color-on-primary: {{ arcade_color_rbg_vars($theme->settings->dark_on_primary_color ?? '#381E72') }};
    --color-primary-container: {{ arcade_color_rbg_vars($theme->settings->dark_primary_container_color ?? '#4F378B') }};
    --color-on-primary-container:  {{ arcade_color_rbg_vars($theme->settings->dark_on_primary_container_color ?? '#EADDFF') }};

    --color-secondary: {{ arcade_color_rbg_vars($theme->settings->dark_secondary_color ?? '#CCC2DC') }};
    --color-on-secondary: {{ arcade_color_rbg_vars($theme->settings->dark_on_secondary_color ?? '#332D41') }};
    --color-secondary-container: {{ arcade_color_rbg_vars($theme->settings->dark_secondary_container_color ?? '#4A4458') }};
    --color-on-secondary-container:  {{ arcade_color_rbg_vars($theme->settings->dark_on_secondary_container_color ?? '#E8DEF8') }};

    --color-tertiary: {{ arcade_color_rbg_vars($theme->settings->dark_tertiary_color ?? '#EFB8C8') }};
    --color-on-tertiary: {{ arcade_color_rbg_vars($theme->settings->dark_on_tertiary_color ?? '#492532') }};
    --color-tertiary-container: {{ arcade_color_rbg_vars($theme->settings->dark_tertiary_container_color ?? '#633B48') }};
    --color-on-tertiary-container:  {{ arcade_color_rbg_vars($theme->settings->dark_on_tertiary_container_color ?? '#FFD8E4') }};

    --color-error: {{ arcade_color_rbg_vars($theme->settings->dark_error_color ?? '#F2B8B5') }};
    --color-on-error: {{ arcade_color_rbg_vars($theme->settings->dark_on_error_color ?? '#601410') }};
    --color-error-container: {{ arcade_color_rbg_vars($theme->settings->dark_error_container_color ?? '#8C1D18') }};
    --color-on-error-container:  {{ arcade_color_rbg_vars($theme->settings->dark_on_error_container_color ?? '#F2B8B5') }};

    --color-background: {{ arcade_color_rbg_vars($theme->settings->dark_background_color ?? '#1C1B1F') }};
    --color-on-background: {{ arcade_color_rbg_vars($theme->settings->dark_on_background_color ?? '#E6E1E5') }};

    --color-surface: {{ arcade_color_rbg_vars($theme->settings->dark_surface_color ?? '#1C1B1F') }};
    --color-on-surface:  {{ arcade_color_rbg_vars($theme->settings->dark_on_surface_color ?? '#E6E1E5') }};
    --color-surface-variant: {{ arcade_color_rbg_vars($theme->settings->dark_surface_variant_color ?? '#49454F') }};
    --color-on-surface-variant:  {{ arcade_color_rbg_vars($theme->settings->dark_on_surface_variant_color ?? '#CAC4D0') }};

    --color-outline: {{ arcade_color_rbg_vars($theme->settings->dark_outline_color ?? '#938F99') }};
  }
</style>
