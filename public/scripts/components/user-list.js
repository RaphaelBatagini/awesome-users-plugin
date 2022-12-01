import { createElement, useState, useEffect } from '@wordpress/element';
import apiFetch from '@wordpress/api-fetch';

export default function UserList() {
  const [ loading, setLoading ] = useState(false);
  const [ users, setUsers ] = useState([]);
  const [ selectedUserId, setSelectedUserId ] = useState();
  const [ userDetails, setUserDetails ] = useState();

  useEffect(() => {
    setLoading(true);

    apiFetch({ path: '/awesome-users/v1/list' }).then((users) => {
      setUsers(users);
      setLoading(false);
    });
  }, []);

  useEffect(() => {
    if (!selectedUserId) {
      return;
    }

    setLoading(true);

    apiFetch({ path: `/awesome-users/v1/details/${selectedUserId}` }).then((user) => {
      setUserDetails(user);
      setLoading(false);
    });
  }, [selectedUserId]);

  const createUserCell = (id, text) => {
    return createElement('td', null, (
      <a href="#" onClick={ () => { setSelectedUserId(id) } }>
        { text }
      </a>
    ));
  }

  const createUserRow = (user) => {
    return createElement(
      'tr',
      null,
      (
        <>
          { createUserCell(user.id, user.id) }
          { createUserCell(user.id, user.name) }
          { createUserCell(user.id, user.username) }
        </>
      )
    );
  }

  const showUsersList = () => {
    return createElement(
      'table',
      null,
      (
        !users 
        ? <>We didn't find any user</>
        : <>
          <tr>
            <td>ID</td>
            <td>Name</td>
            <td>Username</td>
          </tr>
          {
            users.map((user) => {
              return createUserRow(user)
            })
          }
        </>
      )
    );
  }

  const backToUserList = () => {
    setUserDetails(null);
    setSelectedUserId(0);
  }

  const showUserDetails = () => {
    return createElement(
      'div',
      null,
      (
        !userDetails
        ? <>User not found</>
        : (
          <>
            <a href='#' onClick={ () => { backToUserList() } }>Go back</a>
            <h2>Showing data from: { userDetails.name }</h2>
          </>
        )
      )
    );
  }

  return createElement(
    'div',
    null,
    (
      loading 
      ? <>Loading...</>
      : (
        !userDetails
        ? showUsersList()
        : showUserDetails()
      )
    )
  );
}