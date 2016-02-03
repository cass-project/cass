import angular from "angular";
import 'angular-resource';
import app from './app/main';

require("./node_modules/reset-css/reset.css");

import './app/welcome';
import './app/square';

document.addEventListener('DOMContentLoaded', () => {
  angular.bootstrap(document, ['app']);
});