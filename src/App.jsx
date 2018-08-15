import React, { Component } from "react";
import OrderTable from "./Components/OrderTable.jsx";

class App extends Component {
  constructor(props) {
    super(props);
  }

  render() {
    return (
      <div className="App">
        <header className="App-header">
          <h1 className="App-title">Quick Order</h1>
        </header>
        <OrderTable />
      </div>
    );
  }
}

export default App;
