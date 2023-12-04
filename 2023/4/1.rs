use std::io::{self, BufRead};

fn main() -> io::Result<()> {
    let stdin = io::stdin();
    let reader = stdin.lock();

    let mut total: i64 = 0;
    for line in reader.lines() {
        let line = line?;
        let mut subtotal: i64 = 0;
        if line.starts_with("Card") {
            if let Some((card_info, numbers)) = line.split_once(':') {
                println!("{}:", card_info.trim());

                let (left_series, right_series) = numbers.split_once('|').unwrap_or(("", ""));
                let left_numbers: Vec<_> = left_series.split_whitespace().collect();
                let right_numbers: Vec<_> = right_series.split_whitespace().collect();

                for number in right_numbers {
                    if left_numbers.contains(&number) {
                        if subtotal == 0 {
                            subtotal = 1 as i64;
                        } else {
                            subtotal = subtotal.checked_mul(2).unwrap_or(i64::MAX);
                        }
                    }
                }
                total += subtotal;
                println!("subtotal: {}", subtotal);
            }
        }
    }
    println!("total: {}", total);

    Ok(())
}
