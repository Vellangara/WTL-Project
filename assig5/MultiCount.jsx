import { useState } from "react";

function MultiCount({ initial }) {
  const [count, setCount] = useState(initial);

  function add() {
    setCount(count + 1);
  }
  function sub() {
    setCount(count - 1);
  }

  return (
    <div>
      <h3>Count is: {count}</h3>
      <button onClick={add}>Add</button> 
      <button onClick={sub}>Sub</button>
    </div>
  );
}

export default MultiCount;
/*
 */