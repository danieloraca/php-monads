fn divide(numerator: f64, denominator: f64) -> Result<f64, String> {
    if denominator == 0.0 {
        Err("Cannot divide by zero".to_string())
    } else {
        Ok(numerator / denominator)
    }
}

fn double(value: f64) -> f64 {
    value * 2.0
}

fn main() {
    let result = divide(10.0, 2.0)
        .map(double) // If the result is Ok, double the value
        .unwrap_or_else(|err| {
            println!("Error: {}", err);
            0.0 // Default fallback value if there's an error
        });

    println!("Final result: {}", result); // Output: Final result: 10.0
}
