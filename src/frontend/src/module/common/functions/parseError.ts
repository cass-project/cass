export function parseError(error): string {
    if(typeof error === "object") {
        if(error.error && typeof error.error === 'string') {
            return error.error;
        }else{
            return 'Unknown error';
        }
    }else{
        return 'Failed to parse JSON';
    }
}