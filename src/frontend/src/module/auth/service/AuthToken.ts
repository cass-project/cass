import {Injectable} from "angular2/core";

@Injectable()
export class AuthToken
{
    public apiKey: string;

    setToken(apiKey: string) {
        this.apiKey = apiKey;
    }

    getAPIKey(): string {
        return this.apiKey;
    }
    hasToken(): boolean {
        return !! this.apiKey;
    }

    clearAPIKey() {
        this.apiKey = undefined;
    }
}