import React, { Component } from "react";

class Pagination extends Component {
  constructor(props) {
    super(props);

    this.nextPageHandler = this.nextPageHandler.bind(this);
    this.previousPageHandler = this.previousPageHandler.bind(this);
  }

  nextPageHandler() {
    this.props.next();
  }
  previousPageHandler() {
    this.props.previous();
  }

  render() {
    return (
      <div className="quick-order-pagination">
        <nav className="woocommerce-pagination">
          <ul className="page-numbers">
            {this.props.page > 1 && (
              <li onClick={this.previousPageHandler}>
                <a className="prev page-numbers">←</a>
              </li>
            )}
            <li>
              <span aria-current="page" className="page-numbers current">
                {this.props.page}
              </span>
            </li>
            {this.props.page !== this.props.totalPages && (
              <li onClick={this.nextPageHandler}>
                <a className="next page-numbers">→</a>
              </li>
            )}
          </ul>
        </nav>
      </div>
    );
  }
}

export default Pagination;
