import {Criteria} from "../Criteria";

export class ThemeIdCriteria implements Criteria
{
    private themeId: number;

    getName(): string {
        return 'theme_id';
    }

    isAvailable(): boolean {
        return true;
    }

    getParams(): any {
        return {
            'id': this.themeId
        }
    }
}