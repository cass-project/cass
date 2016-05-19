export class ModalControl
{
    private opened: boolean = false;

    public isOpened() {
        return this.opened;
    }

    public open() {
        this.opened = true;
    }

    public close() {
        this.opened = false;
    }
}