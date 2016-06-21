export interface Theme
{
    id: number;
    title: string;
    description: string;
    parent_id: number;
    position: number;
    children?: Theme[];
}