require('./style.scss');

import angular from 'angular';
import routing from './routes';

export class WelcomeComponent
{
  constructor() {
    this.message = 'This is an angular1 app!';
  }
}

angular.module('app')
  .config(routing)
  .controller('WelcomeComponent', WelcomeComponent)
;