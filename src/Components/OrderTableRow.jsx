import React, { Component } from "react";

class OrderTableRow extends Component {
  constructor(props) {
    super(props);
  }

  createMarkup() {
    return { __html: this.props.price };
  }

  render() {
    return (
      <tr>
        <td>
          <img
            className="quick-order-product-image"
            src={this.props.product.image}
          />
        </td>
        <td>{this.props.product.name}</td>
        <td>{this.props.product.sku}</td>
        <td>QTY</td>
        <td>{[this.props.product.price]}</td>
        <td>In Stock?</td>
        <td>
          <a
            href={"/?add-to-cart=" + this.props.product.id}
            data-quantity="1"
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
