declare global {
    interface Window {
        mbsRestApi: {
            root: string;
            nonce: string;
        };
    }
}
export {};
