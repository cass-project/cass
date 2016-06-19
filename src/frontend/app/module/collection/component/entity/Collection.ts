export interface Collection
{
    author_profile_id: string,
    owner_community_id: string,
    title: string,
    description: string,
    theme_ids: Array<any>,
    theme: {has: boolean},
    image: {small: {public_path: string}}
}