require('./style.scss');

import angular from 'angular';
import routing from './routes';

import SquareHomeComponent from './../SquareHomeComponent/component';
import SquareCalculateComponent from './../SquareCalculateComponent/component';

export class SquareCenterComponent
{
  constructor() {}
}

angular.module('app')
  .config(routing)
  .controller('SquareCenterComponent', SquareCenterComponent)
;
