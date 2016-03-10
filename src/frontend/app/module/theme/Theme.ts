export class ThemeHost
{
    id: number;
    domain: string;
}

export class Theme
{
    id: number;
    parent_id: number;
    host: ThemeHost;
    position: number;
    title: string;
    show:boolean;
}

export class ThemeTree
{
    id: number;
    parent_id: number;
    host: ThemeHost;
    position: number;
    title: string;
    children: ThemeTree[];
}