import React, { useState } from 'react';
import './styles.css';

function App() {
  const [isLogin, setIsLogin] = useState(true);
  const [formData, setFormData] = useState({ name: '', email: '', password: '' });

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    
    // PHP API endpoint
    const endpoint = isLogin 
        ? 'http://localhost/login_api.php' 
        : 'http://localhost/register_api.php';

    const response = await fetch(endpoint, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(formData)
    });

    const data = await response.json();
    
    if(data.status === 'success') {
        alert(data.message);
        if(isLogin) {
            window.location.href = '/dashboard'; // Dashboard par redirect karein
        } else {
            setIsLogin(true); // Register hone ke baad login page par le jayein
        }
    } else {
        alert(data.message);
    }
  };

  return (
    <div className="auth-container">
      <div className="auth-box">
        <div className="auth-header">
          <h2>{isLogin ? 'Welcome ' : 'Create ' }<span>{isLogin ? 'Back' : 'Account'}</span></h2>
          <p style={{ color: '#8ab4d6' }}>
            {isLogin ? 'Login to manage your tasks' : 'Register to get started'}
          </p>
        </div>

        <form onSubmit={handleSubmit}>
          {!isLogin && (
            <div className="input-group">
              <label>👤 Full Name</label>
              <input 
                type="text" 
                name="name" 
                placeholder="Enter your name" 
                onChange={handleChange} 
                required 
              />
            </div>
          )}

          <div className="input-group">
            <label>📧 Email Address</label>
            <input 
              type="email" 
              name="email" 
              placeholder="Enter your email" 
              onChange={handleChange} 
              required 
            />
          </div>

          <div className="input-group">
            <label>🔑 Password</label>
            <input 
              type="password" 
              name="password" 
              placeholder="Enter your password" 
              onChange={handleChange} 
              required 
            />
          </div>

          <button type="submit" className="btn-primary">
            {isLogin ? 'Login →' : 'Register →'}
          </button>
        </form>

        <span className="toggle-link" onClick={() => setIsLogin(!isLogin)}>
          {isLogin ? "Don't have an account? Register here" : "Already have an account? Login here"}
        </span>
      </div>
    </div>
  );
}

export default App;