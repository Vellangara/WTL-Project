import React from "react";
import MultiCount from "./MultiCount";

function App() {
  return (
    <div>
      <h2>Multiple Counters</h2>
      <MultiCount initial={10} />
      <MultiCount initial={20} />
      <MultiCount initial={30} />
    </div>
  );
}

export default App;