declare module "alpinejs" {
  export interface AlpineElement extends HTMLElement {
    __x: AlpineInstance;
    [key: string]: any;
  }

  export interface AlpineInstance {
    readonly $el: AlpineElement;
  }

  export type AlpineComponent<T> = {
    [Key in keyof T]: T[Key] extends (...args: infer Args) => infer Return
      ? (this: T & AlpineInstance, ...args: Args) => Return
      : T[Key];
  } & { init?: () => void | Promise<void> };

  const Alpine: {
    start(): void;
    data<T>(
      componentName: string,
      callback: (params: any) => AlpineComponent<T>
    ): void;
  };

  export default Alpine;
}
