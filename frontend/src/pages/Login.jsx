import { useState } from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { loginAction } from '../redux/auth';
import { useNavigate } from 'react-router-dom';

export default function Login() {
  const navigate = useNavigate();
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const dispatch = useDispatch();
  const { loading, error, user } = useSelector((state) => state.auth);

  const handleSubmit = (e) => {
    e.preventDefault();

    const login = {
      email: email,
      password: password,
    };

    dispatch(loginAction(login));
  };

  

  if (loading) {
    return <p>Loading...</p>;
  }

  if (error) {
    return <p>Error: {error.message}</p>;
  }

  if (user) {
    navigate('/');
    return null;
  }

  return (
    <div className="flex justify-center items-center mt-20">
      <div className="w-full max-w-md ">
        <div className="bg-white shadow-lg p-6 rounded-lg">
          <h2 className="text-center text-2xl font-semibold mb-6">LOGIN</h2>
          <i className="fa fa-sign-in text-3xl mb-6 mx-auto"></i>

          <form onSubmit={handleSubmit}>
            <input
              type="text"
              placeholder="Email"
              className="w-full p-2 mb-4 border border-gray-300 rounded"
              value={email}
              required
              onChange={(e) => setEmail(e.target.value)}
            />

            <input
              type="password"
              placeholder="Password"
              className="w-full p-2 mb-4 border border-gray-300 rounded"
              value={password}
              required
              onChange={(e) => setPassword(e.target.value)}
            />

            <div className="text-right">
              <button
                type="submit"
                className="bg-blue-500 text-white px-4 py-2 rounded"
              >
                LOGIN
              </button>
            </div>
          </form>

          <a href="/register" className="block mt-4 text-center">
            Click Here To Register
          </a>
        </div>
      </div>
    </div>
  );
}
