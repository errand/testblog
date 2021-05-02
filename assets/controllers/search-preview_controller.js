import { Controller } from 'stimulus';
import { useClickOutside, useDebounce  } from 'stimulus-use';

export default class extends Controller {

    connect() {
        useClickOutside(this);
        useDebounce(this);
    }

    static values = {
        url: String,
    }

    static targets = ['result'];
    static debounces = ['search'];

    onSearchInput(event) {
        //console.log(event.currentTarget.value);
        this.search(event.currentTarget.value);
    }

    async search(query) {
        const params = new URLSearchParams({
            q: query,
            preview: 1,
        });

        const response = await fetch(`${this.urlValue}?${params.toString()}`);

        this.resultTarget.innerHTML = await response.text();
    }

    clickOutside(event) {
        this.resultTarget.innerHTML = '';
    }
}
