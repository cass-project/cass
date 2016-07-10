import {Injectable} from "angular2/core";
import {Http} from "angular2/http";

@Injectable()

/**
 * @see http://ogp.me/
 */
export class OpenGraphService
{
    constructor(private http: Http) {

    }

    fetch(url) {
        this.http.get(url).subscribe(response => {
            
        })
    }
}