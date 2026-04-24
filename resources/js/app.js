const syncDocumentState = () => {
    document.body.dataset.path = window.location.pathname;
};

document.addEventListener("DOMContentLoaded", syncDocumentState);
document.addEventListener("livewire:navigated", syncDocumentState);
