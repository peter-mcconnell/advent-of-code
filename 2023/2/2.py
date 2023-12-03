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

def main(filename, r, g, b):
    success = 0
    with open(filename, "r") as f:
        lines = f.readlines()
        for line in lines:
            line = line.strip()
            g_split = line.split(":", 1)
            game = int(g_split[0].replace("Game ", "").strip())
            sets = g_split[1].split(";")
            game_valid = True
            for s in sets:
                set_data = parse_set(s)
                if not validate_set(set_data, r, g, b):
                    game_valid = False
                    break
            if game_valid:
                success += game
    return success

if __name__ == "__main__":
    red = 12
    green = 13
    blue = 14
    print(main("input.txt", red, green, blue))
