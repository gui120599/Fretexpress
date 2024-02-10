import './bootstrap';

import Alpine from 'alpinejs';

import jQuery from "jquery";

import Swal from 'sweetalert2';

import Chart from 'chart.js/auto';

import Inputmask from "inputmask";




window.Alpine = Alpine;
window.$ = jQuery;
window.Swal = Swal;
window.Chart = Chart;
window.Mask = Inputmask;

Alpine.start();
