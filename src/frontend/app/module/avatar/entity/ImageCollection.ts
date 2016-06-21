namespace CASSDefinitions {
    namespace Entities
    {
        export interface ImageCollection {
            uid:string;
            variants:{ [size:string]: Image };
        }
    }
}