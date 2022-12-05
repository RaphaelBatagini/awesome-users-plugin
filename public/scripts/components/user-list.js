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
        !users || users.length === 0
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
        !userDetails || userDetails.length === 0
        ? <>User not found</>
        : (
          <>
            <a href='#' onClick={ () => { backToUserList() } }>Go back</a>
            <h3>Showing data for user: #{ userDetails.id }</h3>
            <p>
              <strong>Name</strong><br/>{ userDetails.name }
            </p>
            <p>
              <strong>Username</strong><br/>{ userDetails.username }
            </p>
            <p>
              <strong>E-mail</strong><br/>{ userDetails.email }
            </p>
            <p>
              <strong>Address</strong><br/>
              <ul>
                <li>Street: { userDetails.address?.street }</li>
                <li>Suite: { userDetails.address?.suite }</li>
                <li>City: { userDetails.address?.city }</li>
                <li>Zipcode: { userDetails.address?.zipcode }</li>
                <li>Geo: { userDetails.address?.geo?.lat }, { userDetails.address?.geo?.lng }</li>
              </ul>
            </p>
            <p>
              <strong>Phone</strong><br/>{ userDetails.phone }
            </p>
            <p>
              <strong>Website</strong><br/>{ userDetails.website }
            </p>
            <p>
              <strong>Company</strong><br/>
              <ul>
                <li>Name: { userDetails.company?.name }</li>
                <li>Catch Phrase: { userDetails.company?.catchPhrase }</li>
              </ul>
            </p>
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