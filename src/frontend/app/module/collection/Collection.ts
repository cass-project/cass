export interface Collection
{
    id: number;
    parent_id: number;
    theme_id: number;
    title: string;
    description: string;
    position: number;
}

export interface CollectionLeaf
{
    id: number;
    parent_id: number;
    theme_id: number;
    title: string;
    description: string;
    position: number;
    depth: number;
    children: CollectionLeaf[];
}