import domReady from '@wordpress/dom-ready';
import { render, createElement } from '@wordpress/element';
import UserList from './components/user-list';

domReady(function () {
  render (
    createElement(UserList),
    document.getElementById('awesome-users-plugin-app')
  );
});