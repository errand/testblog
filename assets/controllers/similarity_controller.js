import { Controller } from 'stimulus';
import { useDebounce  } from 'stimulus-use';

export default class extends Controller {

    connect() {
        useDebounce(this);
    }

    static values = {
        url: String,
    }

    static targets = ['results'];
    static debounces = ['highlilght'];

    onSimilarityInput(event) {
        this.highlilght(event.currentTarget.value);
    }

    async highlilght(query) {

        let postId = document.getElementById('post_id').value;

        const params = new URLSearchParams({
            q: query,
            post_id: postId,
        });

        const response = await fetch(`${this.urlValue}?${params.toString()}`);

        //console.log(await response);

        this.resultsTarget.innerHTML = await response.text();
    }


}
