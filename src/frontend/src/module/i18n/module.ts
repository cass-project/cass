import {TranslationService} from "./service/TranslationService";

import {TranslatePipe} from "./pipe/TranslatePipe";

export const CASSI18nModule = {
    declarations: [
        TranslatePipe,
    ],
    providers: [
        TranslationService,
    ]
};