import domReady from '@wordpress/dom-ready';
import { render, createElement } from '@wordpress/element';
import UserList from './components/user-list';

domReady(function () {
  const root = document.getElementById('awesome-users-plugin-app');

  if (!root) {
    return;
  }

  render (
    createElement(UserList),
    root
  );
});