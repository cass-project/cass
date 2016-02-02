require('./style.scss');

import angular from 'angular';
import routing from './routes';

export class SquareCalculateComponent
{
  constructor() {}
}

angular.module('app')
  .config(routing)
  .controller('SquareCalculateComponent', SquareCalculateComponent)
;
