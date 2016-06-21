export interface Theme
{
    id: string;
    title: string;
    description: string;
    parent_id: string;
    position: number;
    children?: Theme[];
}