declare module "@alpinejs/collapse";
declare module "alpinejs" {
  export interface AlpineElement extends HTMLElement {
    __x: AlpineInstance;
    [key: string]: any;
  }

  export interface AlpineInstance {
    readonly $el: AlpineElement;
    $dispatch(event: string, detail?: any): void;
  }

  export type AlpineComponent<T> = {
    [Key in keyof T]: T[Key] extends (...args: infer Args) => infer Return
      ? (this: T & AlpineInstance, ...args: Args) => Return
      : T[Key];
  } & { init?: (this: T & AlpineInstance) => void | Promise<void> };

  const Alpine: {
    start(): void;
    data<T>(
      componentName: string,
      callback: (params: any) => AlpineComponent<T>
    ): void;
    plugin(plugin: any): void;
  };

  export default Alpine;
}
