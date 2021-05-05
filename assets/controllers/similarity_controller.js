import { Controller } from 'stimulus';

export default class extends Controller {

    connect() {
        console.log('similarity connected');
    }

    static values = {
        url: String,
    }

    static targets = ['results'];

    async onSimilarityInput(event) {

        let postId = document.getElementById('post_id').value;

        const params = new URLSearchParams({
            q: event.currentTarget.value,
            post_id: postId,
        });

        const response = await fetch(`${this.urlValue}?${params.toString()}`);

        //console.log(await response);

        this.resultsTarget.innerHTML = '';

        this.resultsTarget.innerHTML = await response.text();
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
