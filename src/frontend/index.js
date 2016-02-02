import angular from "angular";
import app from './app/component';

import WelcomeComponent from './app/component/welcome/WelcomeComponent/component';
import SquareCenterComponent from './app/component/square/SquareCenterComponent/component';

document.addEventListener('DOMContentLoaded', () => {
  angular.bootstrap(document, ['app']);
});