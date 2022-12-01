import { createElement } from '@wordpress/element';

export default function UserList() {
  return createElement(
    'ul',
    null,
    (
      <li>User 1</li>
    )
  );
}