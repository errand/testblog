import { Controller } from 'stimulus';

export default class extends Controller {

    connect() {
        console.log('similarity connected');
    }

    static values = {
        url: String,
    }

    static targets = ['result'];

    onSearchInput(event) {
        //console.log(event.currentTarget.value);
        this.search(event.currentTarget.value);
    }

    async onClick(query) {
        const params = new URLSearchParams({
            q: query,
        });

        const response = await fetch(`${this.urlValue}?${params.toString()}`);

        this.resultTarget.innerHTML = await response.text();
    }

    clickOutside(event) {
        this.resultTarget.innerHTML = '';
    }
}
