import {Injectable} from "angular2/core";

import {FrontlineService} from "../../frontline/service";
import {PostTypeEntity} from "../definitions/entity/PostType";

@Injectable()
export class PostTypeService
{
    private types: PostTypeEntity[] = [];

    constructor(private frontline: FrontlineService) {
        this.types = frontline.session.config.post.types;
    }

    getTypes(): PostTypeEntity[] {
        return this.types;
    }

    getTypeByIntCode(code: number): PostTypeEntity {
        for(let type of this.types) {
            if(type.int === code) {
                return type;
            }
        }

        throw new Error(`Type with code '${code}' not found`);
    }

    getTypeByStringCode(code: string): PostTypeEntity {
        for(let type of this.types) {
            if(type.string === code) {
                return type;
            }
        }

        throw new Error(`Type with code '${code}' not found`);
    }
}