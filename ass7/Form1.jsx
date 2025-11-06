import { useState } from "react";

function Form1() {
  // State object for form fields
  const [form1, setForm1] = useState({ fname: "", lname: "", email: "" });

  // Validation function
  function validate() {
    // Validate first name
    if (form1.fname.length < 3 || /\d/.test(form1.fname)) {
      alert("First name must be at least 3 characters and cannot contain numbers");
      return;
    }

    // Validate last name
    if (form1.lname.length < 3 || /\d/.test(form1.lname)) {
      alert("Last name must be at least 3 characters and cannot contain numbers");
      return;
    }

    // Validate email
    if (!form1.email.includes("@") || !form1.email.includes(".")) {
      alert("Invalid email address: it must contain '@' and '.'");
      return;
    }

    alert(`Form submitted successfully! Welcome ${form1.fname} ${form1.lname}`);
  }

  return (
    <div style={{ fontFamily: "Arial", padding: "20px" }}>
      <h2>Form Validation Example</h2>

      <label>Enter first name: </label>
      <input
        type="text"
        value={form1.fname}
        onChange={(e) => setForm1({ ...form1, fname: e.target.value })}
      />
      <br /><br />

      <label>Enter last name: </label>
      <input
        type="text"
        value={form1.lname}
        onChange={(e) => setForm1({ ...form1, lname: e.target.value })}
      />
      <br /><br />

      <label>Enter email: </label>
      <input
        type="email"
        value={form1.email}
        onChange={(e) => setForm1({ ...form1, email: e.target.value })}
      />
      <br /><br />

      <button onClick={validate}>Submit</button>

      <p>
        Welcome {form1.fname} {form1.lname}
      </p>
    </div>
  );
}

export default Form1;