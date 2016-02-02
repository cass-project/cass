require('./style.scss');

import angular from 'angular';
import routing from './routes';

export class SquareHomeComponent
{
  constructor() {}
}

angular.module('app')
  .config(routing)
  .controller('SquareHomeComponent', SquareHomeComponent)
;
