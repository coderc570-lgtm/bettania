import { NotificationApi } from '@kyvg/vue3-notification';

declare module 'pinia' {
  export interface PiniaCustomProperties {
    $notify: NotificationApi;
  }
}