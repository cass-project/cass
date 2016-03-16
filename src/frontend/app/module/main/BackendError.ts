export class BackendError
{
    private ERROR_MESSAGE_UNKNOWN = 'Unknown error. Please check your internet connection.';

    public message;

    constructor(response) {
        if(response && (typeof response === 'object')) {
            if(response.json) {
                response = response.json();
            }

            if(response.error && (typeof response.error === 'string')) {
                this.message = response.error;
            }else{
                this.message = this.ERROR_MESSAGE_UNKNOWN;
            }
        }else{
            this.message = this.ERROR_MESSAGE_UNKNOWN;
        }
    }
}