import { createFetch } from "@vueuse/core";

const useFetch = createFetch({
  baseUrl: "/admin/arcade",
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
  return useFetch("images").get().json();
}

export function useImportImage(formData: FormData) {
  return useFetch("images").post(formData).json();
}
