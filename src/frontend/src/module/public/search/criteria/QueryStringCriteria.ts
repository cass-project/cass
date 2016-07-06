import {Criteria} from "../Criteria";

export class QueryStringCriteria implements Criteria
{
    private queryString: string;
    
    setQueryString(queryString: string) {
        this.queryString = queryString;
    }

    getName(): string {
        return 'query_string';
    }

    isAvailable(): boolean {
        return this.queryString.length > 0;
    }

    getParams(): any {
        return {
            'query': this.queryString
        }
    }
}