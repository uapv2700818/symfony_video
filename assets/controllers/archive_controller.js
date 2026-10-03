import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    toggle(event) {
        const contenu = event.currentTarget.nextElementSibling;

        contenu.classList.toggle('cache');
    }
}