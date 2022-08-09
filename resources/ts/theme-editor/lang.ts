import get from "lodash/get";
const messages = (window as any).messages;

export function useLang() {
  return {
    t(key: string) {
      return get(messages, key);
    },
  };
}
