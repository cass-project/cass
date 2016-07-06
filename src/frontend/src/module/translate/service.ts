export class TranslateService
{
    private gt = {
        collections: {}
    };
    
    translate(context: string, key: string): string {
        if(this.gt[context] === undefined) {
            throw new Error(`Unknown context '${context.toString()}'`)
        }

        return this.gt[context][key] === undefined
            ? key
            : this.gt[context][key];
    }
}