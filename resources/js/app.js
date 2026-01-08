import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

// Alpine will be initialized by the bundled import; avoid calling
// `Alpine.start()` twice which causes Livewire to warn about
// multiple Alpine instances.
