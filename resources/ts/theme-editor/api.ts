import { createFetch } from "@vueuse/core";
import type { Ref } from "@vue/composition-api";
import { ref } from "@vue/composition-api";

const useFetch = createFetch({
  options: {
    beforeFetch({ options }) {
      if (!options.headers) {
        options.headers = {};
      }

      // (options.headers as any)['Content-Type'] = 'application/json';
      (options.headers as any)["X-CSRF-Token"] = (
        document.querySelector('meta[name="csrf-token"]') as Element
      ).getAttribute("content") as string;

      return { options };
    },
  },
  fetchOptions: {
    mode: "cors",
  },
});

export function useFetchImages() {
  return useFetch("/admin/arcade/images").get().json();
}

export function useImportImage(formData: FormData) {
  return useFetch("/admin/arcade/images").post(formData).json();
}

export function useFetchCategories() {
  return useFetch("/api/categories?pagination=0").get().json();
}

export function useFetchProducts() {
  const url = ref("/api/products");
  const { data, execute: run, ...rest } = useFetch(url, { refetch: true }).get().json();

  function execute(params?: { search: string }) {
    if (params) {
      url.value = `/api/products?${new URLSearchParams(params).toString()}`;
    } else {
      url.value = "/api/products";
    }
  }

  return {
    data,
    execute,
    ...rest,
  };
}
