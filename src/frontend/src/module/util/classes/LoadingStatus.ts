export class LoadingManager
{
    private loading: LoadingStatus[] = [];

    addLoading(): LoadingStatus {
        let status = { is: true };
        this.loading.push(status);

        return status;
    }

    isLoading(): boolean {
        return this.loading.filter(loading => loading.is === true).length > 0;
    }
}

interface LoadingStatus {
    is: boolean;
}