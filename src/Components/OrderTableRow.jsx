import React, { Component } from "react";

class OrderTableRow extends Component {
  constructor(props) {
    super(props);

    // Bind the this context to the handler function
    this.handleQtyChange = this.handleQtyChange.bind(this);
    //this.displayInstock = this.displayInstock.bind(this);

    // Set some state
    this.state = {
      productQty: 1
    };
  }

  handleQtyChange(event) {
    this.setState({ productQty: event.target.value });
  }

  // Returns display for product stock status.
  displayInstock() {
    if (this.props.product && this.props.product.status === "outofstock") {
      return "NO";
    }
    return "YES";
  }

  render() {
    return (
      <tr>
        <td>
          <img
            className="quick-order-product-image"
            src={this.props.product.image}
            alt={this.props.product.name}
          />
        </td>
        <td>{this.props.product.name}</td>
        <td>{this.props.product.sku}</td>
        <td>
          <div className="quantity">
            <label className="screen-reader-text">Quantity</label>
            <input
              type="number"
              className="input-text qty text"
              value={this.state.productQty}
              onChange={this.handleQtyChange}
              min="1"
              title="Qty"
            />
          </div>
        </td>
        <td dangerouslySetInnerHTML={{ __html: this.props.product.price }} />
        <td>{this.displayInstock()}</td>
        <td>
          <a
            href={"/?add-to-cart=" + this.props.product.id}
            data-quantity={this.state.productQty}
            className="button product_type_simple add_to_cart_button ajax_add_to_cart"
            rel="nofollow"
            data-product_id={this.props.product.id}
          >
            Add to cart
          </a>
        </td>
      </tr>
    );
  }
}

export default OrderTableRow;
