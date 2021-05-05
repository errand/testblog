import { Controller } from 'stimulus';


export default class extends Controller {

    connect() {
        console.log('connected submit confirm');
    }

    onSubmit(event) {
        event.preventDefault();
        console.log(event);
    }

}
