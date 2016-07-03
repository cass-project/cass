export class TranslateService
{
    private gt = {
        collection: {
            '$gt_collection_my-feed_title': 'Моя лента',
            '$gt_collection_my-feed_description': 'Лента с вашими постами',
        }
    };
    
    translate(context: string, key: string): string {
        if(this.gt[context] === undefined) {
            throw new Error(`Unknown context '${context.toString()}'`)
        }

        console.log(context, key, this.gt[context][key]);

        return this.gt[context][key] === undefined
            ? key
            : this.gt[context][key];
    }
}