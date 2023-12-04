use std::io::{self, BufRead};
use std::collections::HashMap;

fn main() -> io::Result<()> {
    let stdin = io::stdin();
    let reader = stdin.lock();
    let mut total: i64 = 0;
    let mut line_no: i64 = 0;
    let mut hits: HashMap<i64, i64> = HashMap::new();
    for line_result in reader.lines() {
        let line = line_result?;
        let cur_hits = hits.entry(line_no).or_insert(0);
        *cur_hits += 1;
        for _ in 0..*cur_hits {
            if line.starts_with("Card") {
                if let Some((_card_info, numbers)) = line.split_once(':') {
                    let (left_series, right_series) = numbers.split_once('|').unwrap_or(("", ""));
                    let left_numbers: Vec<_> = left_series.split_whitespace().collect();
                    let right_numbers: Vec<_> = right_series.split_whitespace().collect();
                    let mut offset: i64 = 0;
                    for number in right_numbers {
                        if left_numbers.contains(&number) {
                            offset += 1;
                            let cur_hits = hits.entry(line_no + offset).or_insert(0);
                            *cur_hits += 1;
                        }
                    }
                }
            }
            total += 1;
        }
        line_no += 1;
    }
    println!("total: {}", total);
    Ok(())
}
