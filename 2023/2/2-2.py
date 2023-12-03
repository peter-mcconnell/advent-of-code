#!/usr/bin/env python3

def parse_set(set_str):
    ret = {
        "red": 0,
        "green": 0,
        "blue": 0
    }
    set_split = set_str.split(",")
    for s in set_split:
        s = s.strip()
        s_parts = s.split(" ", 1)
        if s_parts[1] == "red":
            ret["red"] += int(s_parts[0])
        elif s_parts[1] == "blue":
            ret["blue"] += int(s_parts[0])
        elif s_parts[1] == "green":
            ret["green"] += int(s_parts[0])
    return ret

def validate_set(set_data, r, g, b):
    return set_data["red"] <= r and set_data["blue"] <= b and set_data["green"] <= g

def main(filename):
    success = 0
    with open(filename, "r") as f:
        lines = f.readlines()
        for line in lines:
            line = line.strip()
            g_split = line.split(":", 1)
            game = int(g_split[0].replace("Game ", "").strip())
            sets = g_split[1].split(";")
            mg, mb, mr = 1, 1, 1
            for s in sets:
                set_data = parse_set(s)
                if set_data["red"] > mr:
                    mr = set_data["red"]
                if set_data["blue"] > mb:
                    mb = set_data["blue"]
                if set_data["green"] > mg:
                    mg = set_data["green"]
            success += mg * mb * mr
    return success

if __name__ == "__main__":
    print(main("input.txt"))
